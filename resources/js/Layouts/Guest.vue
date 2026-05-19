<script setup>
import { Link } from '@inertiajs/vue3'
</script>

<template>
  <div class="min-h-screen flex flex-col bg-base-200">
    <main class="flex-1">
      <slot />
    </main>

    <footer class="footer footer-center p-4 bg-base-300 text-base-content">
      <aside>
        <p>&copy; {{ new Date().getFullYear() }} {{ $page.props.appName ?? 'AchouLar' }}. Todos os direitos reservados.</p>
      </aside>
    </footer>
  </div>
</template>
