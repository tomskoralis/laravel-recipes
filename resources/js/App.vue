<template>
    <div class="navigation-wrapper">
        <div class="navigation-container">
            <nav class="navigation-links">
                <RouterLink to="/">Recipes</RouterLink>
                <RouterLink to="/new">New Recipe</RouterLink>
            </nav>
        </div>
    </div>
    <div class="main-wrapper">
        <div class="main-container">
            <RouterView/>
        </div>
    </div>
    <div class="footer-wrapper">
        <footer class="footer">
            Made by Toms Korālis
        </footer>
    </div>
</template>

<script setup lang="ts">
import {RouterLink, RouterView} from "vue-router";
</script>

<style scoped lang="scss">
@import '../css/app.scss';

.navigation-wrapper {
    margin-bottom: 1rem;
    background-color: $secondary-background-color;

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
                color: $background-color;
                display: flex;
                align-items: center;
                transition: ease-in-out 0.2s;

                &:hover {
                    color: $link-hover-color;
                    background-color: $background-color;
                    box-shadow: 3px 3px $secondary-background-color;
                    transform: translate(-3px, -3px);
                }

                &:active {
                    background-color: $border-color;
                }
            }
        }
    }
}

.main-wrapper {
    margin: 0 1rem;

    .main-container {
        min-width: 12rem;
        max-width: 55rem;
        margin: 0 auto;
        word-break: break-word;

        @include for-at-least($breakpoint-md) {
            padding: 1rem;
        }
    }
}

.footer-wrapper {
    background-color: $secondary-background-color;
    min-height: 2rem;
    margin-top: auto;

    .footer {
        margin: 0 auto;
        padding: 0.5rem;
        color: $background-color;
        width: fit-content;
    }
}
</style>
