<template>
    <h1 class="page-heading">New Recipe</h1>

    <form @submit.prevent="handleSubmit" action="" class="form">
        <TextInput
            id="name"
            name="name"
            label="Name"
            placeholder="Name of the recipe"
            v-model:inputValue="state.name.value"
            :error="state.name.error"
        />

        <TextAreaInput
            id="description"
            name="description"
            label="Description"
            placeholder="Describe the recipe"
            v-model:inputValue="state.description.value"
            :error="state.description.error"
        />

        <TextAreaInput
            id="instructions"
            name="instructions"
            label="Instructions"
            placeholder="How to prepare the recipe"
            v-model:inputValue="state.instructions.value"
            :error="state.instructions.error"
        />

        <div>
            <p>Ingredients</p>
            <div v-for="ingredient in state.ingredients.value" :key="ingredient.key" class="ingredient-input">
                <TextInput
                    :id="'name-'+ingredient.key"
                    :name="'name-'+ingredient.key"
                    label=""
                    placeholder="Ingredient"
                    v-model:inputValue="ingredient.name"
                />

                <TextInput
                    :id="'amount-'+ingredient.key"
                    :name="'amount-'+ingredient.key"
                    label=""
                    placeholder="Amount"
                    v-model:inputValue="ingredient.amount"
                />

                <button type="button" class="danger-button" @click="deleteIngredient(ingredient.key)">
                    Remove
                </button>
            </div>
            <p v-if="state.ingredients.error" class="error">{{ state.ingredients.error }}</p>
        </div>

        <button type="button" class="button" @click="addIngredient()">Add ingredient</button>

        <TextInput
            id="image"
            name="image"
            label="Image"
            placeholder="URL to the image"
            v-model:inputValue="state.image.value"
            :error="state.image.error"
        />

        <div class="button-container">
            <button type="button" class="button" @click="router.back()">Go back</button>
            <button type="submit" class="button">Submit</button>
        </div>
    </form>
</template>

<script lang="ts" setup>
import axios from "axios";
import {reactive} from "vue";
import {useRouter} from "vue-router";
import TextInput from "../components/TextInput.vue";
import TextAreaInput from "../components/TextAreaInput.vue";

interface Ingredient {
    key: string;
    name: string;
    amount: string;
}

const router = useRouter();
const url = "http://127.0.0.1:8000/api/v1/recipes";
const config = {
    headers: {
        "Accept": "application/json",
        "Content-Type": "application/json",
    }
};

const state = reactive({
    name: {
        value: "",
        error: "",
    },
    description: {
        value: "",
        error: "",
    },
    instructions: {
        value: "",
        error: "",
    },
    image: {
        value: "",
        error: "",
    },
    ingredients: {
        value: [
            {
                key: Math.random().toString(36).slice(2),
                name: "",
                amount: "",
            },
        ] as Ingredient[],
        error: "",
    },
});

const addIngredient = () => {
    const ingredient: Ingredient = {
        key: Math.random().toString(36).slice(2),
        name: "",
        amount: "",
    };
    state.ingredients.value.push(ingredient);
}

const deleteIngredient = (key: string) => {
    const index = state.ingredients.value.findIndex((ingredient: Ingredient): boolean => {
        return ingredient.key === key;
    });
    if (index > -1) {
        state.ingredients.value.splice(index, 1);
    }
}


const isNameValid = (): Boolean => {
    if (!state.name.value) {
        state.name.error = "Name is required!";
        return false;
    }
    if (state.name.value.length < 8) {
        state.name.error = "Name must contain at least 8 characters!";
        return false;
    }
    if (state.name.value.length > 63) {
        state.name.error = "Name cannot contain more than 63 characters!";
        return false;
    }
    return true;
}

const isDescriptionValid = (): Boolean => {
    if (!state.description.value) {
        state.description.error = "Description is required!";
        return false;
    }
    if (state.description.value.length < 20) {
        state.description.error = "Description must contain at least 20 characters!";
        return false;
    }
    if (state.description.value.length > 255) {
        state.description.error = "Description cannot contain more than 255 characters!";
        return false;
    }
    return true;
}

const areInstructionsValid = (): Boolean => {
    if (!state.instructions.value) {
        state.instructions.error = "Instructions are required!";
        return false;
    }
    if (state.instructions.value.length < 40) {
        state.instructions.error = "Instructions must contain at least 40 characters!";
        return false;
    }
    if (state.instructions.value.length > 2047) {
        state.instructions.error = "Instructions cannot contain more than 2047 characters!";
        return false;
    }
    return true;
}

const areIngredientsValid = (): Boolean => {
    if (state.ingredients.value.length === 0) {
        state.ingredients.error = "Recipe must have at least 1 ingredient!";
        return false;
    }

    return state.ingredients.value.every(ingredient => {
        if (!ingredient.name) {
            state.ingredients.error = "Each ingredient must have a name!";
            return false;
        }
        if (!ingredient.amount) {
            state.ingredients.error = "Each ingredient must have an amount!";
            return false;
        }
        if (ingredient.name.length > 255) {
            state.ingredients.error = "Ingredient's name cannot contain more than 255 characters!";
            return false;
        }
        if (ingredient.amount.length > 63) {
            state.ingredients.error = "Ingredient's amount cannot contain more than 63 characters!";
            return false;
        }
        return true;
    })
}

const isUrlValid = (): Boolean => {
    if (!state.image.value) {
        return true;
    }
    const urlRegex = new RegExp(/https?:\/\/(www\.)?[-a-zA-Z0-9@:%._~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b([-a-zA-Z0-9()@:%_.~#?&/=]*)/i);
    if (!urlRegex.test(state.image.value)) {
        state.image.error = "Incorrect URL!";
        return false;
    }
    return true;
}

const sendRecipe = async () => {
    try {
        const params = {
            name: state.name.value,
            description: state.description.value,
            instructions: state.instructions.value,
            ingredients: state.ingredients.value.map(ingredient => {
                return {
                    name: ingredient.name,
                    amount: ingredient.amount,
                }
            }),
            image: state.image.value,
        }
        await axios.post(`${url}`, params, config);

    } catch (error) {
        console.log("error", error);
    }
}

const handleSubmit = () => {
    let errorCount = 0;
    state.name.error = "";
    state.description.error = "";
    state.instructions.error = "";
    state.ingredients.error = "";
    state.image.error = "";
    if (!isNameValid()) errorCount++;
    if (!isDescriptionValid()) errorCount++;
    if (!areInstructionsValid()) errorCount++;
    if (!areIngredientsValid()) errorCount++;
    if (!isUrlValid()) errorCount++;
    if (errorCount > 0) return;
    sendRecipe();
    router.back();
};
</script>

<style lang="scss" scoped>
.form {
    width: 100%;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.error {
    color: red;
}

.ingredient-input {
    width: 100%;
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    column-gap: 1rem;
    row-gap: 0.2rem;
}

.button-container {
    display: flex;
    align-items: center;
    justify-content: space-between;
}
</style>
