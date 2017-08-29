Robo Wrapper for Laravel
============================

This is (currentl very thin) wrapper around laravel projects for using it in the
Robo task runner.

Commands
--------

Execute artisan

    $this->taskArtisanStack()->exec($command)
    
Shortcut for the above:
    
    $this->_artisan($command);
