import { Product } from "@/types";
import ProductListItem from "./ProductListItem";

export default function ProductList({ products, onClear, onRemove }: {
    products: Product[];
    onClear: () => void;
    onRemove?: (productId: number) => void;
}) {
    return (
        <ul className="shadow-sm list bg-base-100 rounded-box">
            <li className="flex items-center justify-between gap-2 p-4 bg-base-200">
                <span className="opacity-60">{`Selected products (${products.length})`}</span>
                <button type="button" className="btn btn-ghost btn-sm" onClick={onClear}>{'Clear all'}</button>
            </li>
            {products.map(product => (
                <ProductListItem
                    key={product.id}
                    product={product}
                    onRemove={onRemove}
                />
            ))}
        </ul>
    );
}