# Robo Wrapper for Laravel

This is (currentl very thin) wrapper around laravel projects for using it in the
Robo task runner.

## Commands

### Execute artisan

    $this->taskArtisanStack()->exec($command)->run();
    
Shortcut for the above:
    
    $this->_artisan($command);

### Flush Caches

Adds only to the stack, so you can run additional commands

    $this->taskArtisanStack()->addCacheFlush()->run();
    
Shortcut for the above:
        
    $this->_artisanCacheFlush($command);