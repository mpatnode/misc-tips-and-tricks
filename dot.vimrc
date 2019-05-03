" :s/\($node->attributes\[.*\]\)/\1 ?? NULL
" s/\($node->.*\))/!empty(\1)/
set sw=4
set ts=4
set softtabstop=4
set ai
set aw
set expandtab
syn on
" Syntax highlighting for Drupal filetypes
if has("autocmd")
    " Drupal *.module and *.install files.
    augroup module
        autocmd BufRead,BufNewFile *.module set filetype=php
        autocmd BufRead,BufNewFile *.batch set filetype=php
        autocmd BufRead,BufNewFile *.engine set filetype=php
        autocmd BufRead,BufNewFile *.install set filetype=php
        autocmd BufRead,BufNewFile *.test set filetype=php
        autocmd BufRead,BufNewFile *.inc set filetype=php
        autocmd BufRead,BufNewFile *.profile set filetype=php
        autocmd BufRead,BufNewFile *.view set filetype=php
    augroup END
endif

" For write as root...
cmap w!! %!sudo tee > /dev/null %
