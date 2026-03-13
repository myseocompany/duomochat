@php
    $versionPath = base_path('VERSION');
    $appVersion = is_file($versionPath)
        ? trim((string) file_get_contents($versionPath))
        : '0.0.0';
    $lastUpdatedPath = base_path('LAST_UPDATED');
    $lastUpdated = is_file($lastUpdatedPath)
        ? trim((string) file_get_contents($lastUpdatedPath))
        : now()->format('Y-m-d');
@endphp

<footer class="footer text-center">
        <p>Hecho para &copy; Proyectos Duomo 2025 por My SEO Company</p>
        <p>Version {{ $appVersion }}</p>
        <p>Ultima actualizacion {{ $lastUpdated }}</p>
        {{-- Dentro de tu archivo Blade orders/index.blade.php --}}
        <!--
        <p>Valor de la cookie unique_machine: {{ request()->cookie('unique_machine') }}</p>
        -->
</footer>
