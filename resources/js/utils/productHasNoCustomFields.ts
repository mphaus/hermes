import { Product } from "@/types";

export default function productHasNoCustomFields(product: Product): boolean {
    return !product.custom_fields
        || Object.keys(product.custom_fields).length === 0
        || Object.values(product.custom_fields).every((value) => value === "");
}