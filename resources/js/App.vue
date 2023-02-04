<template>
    <div class="navigation-wrapper">
        <div class="navigation-container">
            <nav class="navigation-links">
                <RouterLink to="/">Recipes</RouterLink>
                <RouterLink to="/new">New Recipe</RouterLink>
            </nav>
        </div>
    </div>
    <MainContainer>
        <RouterView/>
    </MainContainer>
</template>

<script setup lang="ts">
import {RouterLink, RouterView} from "vue-router";
import MainContainer from "./components/MainContainer.vue";
</script>

<style scoped lang="scss">
.navigation-wrapper {
    border-bottom: 2px solid #ccc;
    margin-bottom: 1rem;

    .navigation-container {
        margin: 0 auto;
        min-width: 12rem;
        max-width: 55rem;

        .navigation-links {
            margin: 0 1rem;
            display: flex;
            gap: 0.5rem;
            align-items: center;
            flex-wrap: wrap;

            a {
                height: 3rem;
                padding: 0.5rem;
                text-decoration: none;
                color: #000;
                display: flex;
                align-items: center;
                transition: ease-in-out 0.2s;

                &:hover {
                    color: #1d95c9;
                    box-shadow: 2px 2px #ccc;
                    transform: translate(-2px, -2px);
                }

                &:active {
                    background-color: #ddd;
                }
            }
        }
    }

}
</style>
