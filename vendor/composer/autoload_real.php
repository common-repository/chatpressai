<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInit3c8c115a7be1f3e5f7ccdde5c1f5155a
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        spl_autoload_register(array('ComposerAutoloaderInit3c8c115a7be1f3e5f7ccdde5c1f5155a', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInit3c8c115a7be1f3e5f7ccdde5c1f5155a', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInit3c8c115a7be1f3e5f7ccdde5c1f5155a::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
