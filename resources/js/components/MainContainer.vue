<template>
    <div class="wrapper">
        <div class="container">
            <slot></slot>
        </div>
    </div>
</template>

<style scoped lang="scss">
.wrapper {
    margin: 0 1rem;

    .container {
        min-width: 12rem;
        max-width: 55rem;
        margin: 0 auto;
        padding: 1rem;
        border: 2px solid #ccc;
        border-radius: 1rem;
        word-break: break-word;
    }
}
</style>
