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
    
### Write .env File

Writes the env file with the values from the setup.
Of course you can add additional mappings as a secound parameter.

Currently RegExp replacing is done.  Sooner or later we might use  https://github.com/nordcode/robo-parameters
for this task (which does not keep comments, that's why we use the own method)
 
    $this->_writeEnvFile($this->askSetup());
    
### Update IDE Helper

Needs https://github.com/barryvdh/laravel-ide-helper

    $this->taskArtisanStack()->addUpdateIdeHelper()->run();
