import { Product } from "@/types";

const STORAGE_CUSTOM_FIELD_KEYS = [
    'colour_coded_storage',
    'nally_bin_storage',
    'nally_bin_storage_stored_at_height',
    'tub_storage',
] as const satisfies ReadonlyArray<keyof NonNullable<Product['custom_fields']>>;

export default function productHasNoCustomFields(product: Product): boolean {
    if (!product.custom_fields || Object.keys(product.custom_fields).length === 0) {
        return true;
    }

    return STORAGE_CUSTOM_FIELD_KEYS.every(
        (key) => (product.custom_fields![key] ?? '') === ''
    );
}
