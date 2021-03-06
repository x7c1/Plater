<?

if(!class_exists('x7c1_PlaterLoader')) {
    class x7c1_PlaterLoader {
        private $main_dir;

        public function __construct(){
            $this->main_dir = realpath(__DIR__ . '/../main');
        }
        public function __invoke($class){
            $path = str_replace('x7c1\plater', $this->main_dir, $class);
            require_once str_replace('\\', '/', $path) . '.php';
        }
    }
    spl_autoload_register(new x7c1_PlaterLoader);
}

