import {createRouter, createWebHistory} from "vue-router";
import RecipesView from "../views/RecipesView.vue";
import RecipeView from "../views/RecipeView.vue";
import EditRecipe from "../views/EditRecipeView.vue";
import NewRecipe from "../views/NewRecipeView.vue";

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: "/",
            name: "Recipes",
            component: RecipesView,
        },
        {
            path: "/recipes/:id",
            name: "Recipe",
            component: RecipeView,
        },
        {
            path: "/recipes/:id/edit",
            name: "Edit Recipe",
            component: EditRecipe,
        },
        {
            path: "/new",
            name: "New Recipe",
            component: NewRecipe,
        },
    ],
});

router.beforeEach((to, _, next) => {
    document.title = String(to.name);
    next();
});

export default router;
