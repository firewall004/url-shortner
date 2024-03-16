<template>
    <div>
        <header>
            <nav-component></nav-component>
        </header>
        <main>
            <slot></slot>
        </main>
        <footer>
            <slot name="footer"></slot>
        </footer>
    </div>
</template>


<script>
import NavComponent from './NavComponent.vue'

export default {
    name: 'BaseLayout',
    components: {
        NavComponent
    }
};

</script>
