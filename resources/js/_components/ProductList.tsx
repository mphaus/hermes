import { Product } from "@/types";
import { X } from "lucide-react";
import ProductListItem from "./ProductListItem";

export default function ProductList({ products }: {
    products: Product[];
}) {
    return (
        <ul className="shadow-sm list bg-base-100 rounded-box">
            <li className="flex items-center justify-between gap-2 p-4 bg-base-200">
                <span className="opacity-60">{`Selected products (${products.length})`}</span>
                <button className="btn btn-ghost btn-sm">{'Clear all'}</button>
            </li>
            {products.map(product => (
                <ProductListItem
                    key={product.id}
                    product={product}
                />
            ))}
        </ul>
    );
}