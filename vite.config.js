import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                // isi disini asset css dan JS template (untuk image masukkan saja langsung di folder publik)
                'resources/assets/vendor/fontawesome-free/css/all.min.css',
                'resources/assets/css/sb-admin-2.min.css',
                'resources/assets/vendor/datatables/datatables.min.css',
                'resources/assets/vendor/select2/select2.min.css',

                'resources/assets/vendor/datatables/datatables.min.js',
                'resources/assets/vendor/jquery/jquery.min.js',
                'resources/assets/vendor/bootstrap/js/bootstrap.bundle.min.js',
                'resources/assets/vendor/jquery-easing/jquery.easing.min.js',
                'resources/assets/js/sb-admin-2.min.js',
                'resources/assets/vendor/select2/select2.min.js',
                // 'resources/assets/vendor/chart.js/Chart.min.js',
                // 'resources/assets/js/demo/chart-area-demo.js',
                // 'resources/assets/js/demo/chart-pie-demo.js',

            ],
            refresh: true,
        }),
    ],
});
