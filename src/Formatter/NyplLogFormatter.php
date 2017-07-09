<?php
namespace NYPL\Starter\Formatter;

use Monolog\Formatter\JsonFormatter;

class NyplLogFormatter extends JsonFormatter
{
    protected function translageLevelToInteger($level = '')
    {
        switch ($level) {
            case 'DEBUG':
                return 7;
            case 'INFO':
                return 6;
            case 'NOTICE':
                return 5;
            case 'WARNING':
                return 4;
            case 'ERROR':
                return 3;
            case 'CRITICAL':
                return 2;
            case 'ALERT':
                return 1;
            case 'EMERGENCY':
                return 0;
        }
    }


    protected function translateMonologLevelToString($level = 0)
    {
        switch ($level) {
            case 100:
                return 'DEBUGS';
            case 200:
                return 'INFO';
            case 250:
                return 'NOTICE';
            case 300:
                return 'WARNING';
            case 400:
                return 'ERROR';
            case 500:
                return 'CRITICAL';
            case 550:
                return 'ALERT';
            case 600:
                return 'EMERGENCY';
        }
    }

    /**
     * @param array $record
     *
     * @return string
     */
    public function format(array $record)
    {
        $record['level'] = $this->translateMonologLevelToString($record['level']);

        $record['levelCode'] = $this->translageLevelToInteger($record['level']);

        $record['datetime'] = date('c');

        unset($record['level_name'], $record['channel']);

        if (!$record['extra']) {
            unset($record['extra']);
        }

        if (!$record['context']) {
            unset($record['context']);
        }

        $record = parent::format($record);

        return $record;
    }
}