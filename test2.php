<?php
print_r(chdir('/root/graderga-grader/'));
mkdir('test');
chdir('./test/');
echo getcwd();
?>