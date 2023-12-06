<?php

namespace Foo\Bar;

include('user.php');

subnamespace\bar();
subnamespace\foo::staticmethod();

\Foo\Bar\subnamespace\bar();
\Foo\Bar\subnamespace\foo::staticmethod();
echo \Foo\Bar\subnamespace\FOO;
?>