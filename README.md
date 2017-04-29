# Smart ProgressBar

This a little study project to make a progressbar more smarty :D

The first goal was create a ConsoleProgressBar, that make a more
easier see a task progress.


### Instalation

```
via composer:

composer require jjsquady/smart-progressbar
```

### Usage

```
$someLength = 10000;
$progressBar = ConsoleProgressBar::init($someLength);

// Inside the task
echo $progressBar->update($currentLength)->render();

//or
echo $progressBar->increment($amountLength)->render();
```

Thats it! Thanks!

Licence MIT.