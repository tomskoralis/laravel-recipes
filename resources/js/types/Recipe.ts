import type {Ingredient} from "./Ingredient";

export interface Recipe {
    id: number;
    name: string;
    description: string;
    ingredients: Ingredient[];
    instructions: string;
    image: string | null;
    created_at: string;
}
