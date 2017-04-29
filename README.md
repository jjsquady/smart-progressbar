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

### Output

```$php
// the output render some like
[======>         ] (25%) 2500/10000 Lines. Remaining 2 sec. Elapsed 5 sec.
```

Thats it! Thanks!

Licence MIT.