<template>
    <h1 class="logo" :style="{ fontSize: `${size}px` }">
        {{ app_name }}
    </h1>
</template>
<script>
export default {
    props: {
        size: {
            type: String,
            default: '60',
        }
    },
    computed: {
        app_name() {
            return laravel.config.name
        }
    },
}
</script>
<style lang="scss" scoped>
@import '../../../sass/variables';

.logo {
    letter-spacing: -2px;
    color: inherit;
    display: flex;
    align-items: center;
    position: relative;
    font-weight: 900;
    color: #3f3f3f;
    font-weight: bolder;
    margin-bottom: 0;

    b {
        color: $primary;
        font-size: 50%;
        margin-left: 10%;
    }
}
</style>