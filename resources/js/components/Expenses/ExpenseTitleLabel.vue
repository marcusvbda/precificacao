<template>
    <div class="d-flex flex-row justify-content-between align-items-center">
        <b>{{ item.name }}</b>
        <div class="mx-2 mr-1">-</div>
        <div class="ml-2 mr-1">{{ item.f_value }}</div>
        <small class="text-muted">( {{ item.f_type }} )</small>
    </div>
</template>
<script>
export default {
    computed: {
        item() {
            return this.$parent.item;
        }
    },
};
</script>