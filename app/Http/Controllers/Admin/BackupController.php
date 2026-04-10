<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class BackupController extends Controller
{
    public function download()
    {
        $dbHost     = Config::get('database.connections.mysql.host');
        $dbPort     = Config::get('database.connections.mysql.port', 3306);
        $dbName     = Config::get('database.connections.mysql.database');
        $dbUser     = Config::get('database.connections.mysql.username');
        $dbPassword = Config::get('database.connections.mysql.password');

        $filename = 'backup-' . $dbName . '-' . now()->format('Ymd-His') . '.sql';

        // Coba generate via mysqldump jika tersedia di server
        $mysqldump = $this->findMysqldump();

        if ($mysqldump) {
            $command = sprintf(
                '%s --user=%s --password=%s --host=%s --port=%s --databases %s --add-drop-database --add-drop-table --routines --triggers 2>/dev/null',
                escapeshellcmd($mysqldump),
                escapeshellarg($dbUser),
                escapeshellarg($dbPassword),
                escapeshellarg($dbHost),
                escapeshellarg($dbPort),
                escapeshellarg($dbName)
            );

            $output = [];
            exec($command, $output);

            if (!empty($output)) {
                $sql = implode("\n", $output);
                return response($sql, 200, [
                    'Content-Type'        => 'application/octet-stream',
                    'Content-Disposition' => "attachment; filename=\"$filename\"",
                ]);
            }
        }

        // Fallback: generate SQL manual via PHP (tanpa mysqldump)
        $sql = $this->generateSqlManually($dbName);

        return response($sql, 200, [
            'Content-Type'        => 'application/octet-stream',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ]);
    }

    private function findMysqldump(): ?string
    {
        $candidates = [
            'mysqldump',
            '/usr/bin/mysqldump',
            '/usr/local/bin/mysqldump',
            'C:\\laragon\\bin\\mysql\\mysql-8.0.30-winx64\\bin\\mysqldump.exe',
        ];

        foreach ($candidates as $path) {
            exec("$path --version 2>&1", $out, $code);
            if ($code === 0) {
                return $path;
            }
        }

        return null;
    }

    private function generateSqlManually(string $dbName): string
    {
        $lines = [];
        $lines[] = "-- =============================================";
        $lines[] = "-- Database Backup: $dbName";
        $lines[] = "-- Generated: " . now()->toDateTimeString();
        $lines[] = "-- =============================================";
        $lines[] = "";
        $lines[] = "SET FOREIGN_KEY_CHECKS=0;";
        $lines[] = "";

        $tables = DB::select('SHOW TABLES');
        $tableKey = "Tables_in_$dbName";

        foreach ($tables as $tableRow) {
            $table = $tableRow->$tableKey;

            // DROP + CREATE table
            $createResult = DB::select("SHOW CREATE TABLE `$table`");
            $createSql    = $createResult[0]->{'Create Table'};

            $lines[] = "-- ----------------------------";
            $lines[] = "-- Table: $table";
            $lines[] = "-- ----------------------------";
            $lines[] = "DROP TABLE IF EXISTS `$table`;";
            $lines[] = $createSql . ";";
            $lines[] = "";

            // INSERT rows
            $rows = DB::table($table)->get();
            if ($rows->isNotEmpty()) {
                foreach ($rows as $row) {
                    $values = array_map(function ($val) {
                        if (is_null($val)) return 'NULL';
                        return "'" . addslashes($val) . "'";
                    }, (array) $row);

                    $lines[] = "INSERT INTO `$table` VALUES (" . implode(', ', $values) . ");";
                }
                $lines[] = "";
            }
        }

        $lines[] = "SET FOREIGN_KEY_CHECKS=1;";

        return implode("\n", $lines);
    }
}
