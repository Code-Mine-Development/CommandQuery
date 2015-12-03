<?php
/**
 * @author Radek Adamiec <radek@code-mine.com>.
 */

namespace CodeMine\CommandQuery;

abstract class AbstractQueryHandler
{
    /**
     * @param \CodeMine\CommandQuery\CommandQueryInterface $commandQueryInterface
     *
     * @return mixed
     */
    abstract function handle(CommandQueryInterface $commandQueryInterface);

}