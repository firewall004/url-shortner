<template>
    <div>
        <header>
            <nav-bar></nav-bar>
        </header>
        <main>
            <slot></slot>
        </main>
        <footer-bar />
    </div>
</template>


<script>
import NavBar from './NavBar.vue'
import FooterBar from './FooterBar.vue'

export default {
    name: 'BaseLayout',
    components: {
        NavBar,
        FooterBar
    }
};

</script>
