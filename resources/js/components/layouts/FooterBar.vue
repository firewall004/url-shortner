<template>
    <footer class="footer bg-light py-3 mt-5">
        <div class="container text-center">
            <hr class="my-2">
            <p>&copy; {{ new Date().getFullYear() }} {{ appName }}. All rights reserved.</p>
        </div>
    </footer>
</template>

<script>
export default {
    name: 'FooterBar',
    data() {
        return {
            appName: process.env.MIX_APP_NAME,
        };
    },
};
</script>
