import { Product } from "@/types";
import { X } from "lucide-react";

export default function ProductListItem({ product }: {
    product: Product;
}) {
    return (
        <li className="items-center list-row">
            <div><img className="size-10 rounded-box" src={product.icon?.thumb_url || 'https://placehold.co/40x40?text=No+image'} alt={product.name} /></div>
            <div>{product.name}</div>
            <button className="btn btn-square btn-ghost">
                <X size={16} />
            </button>
        </li>
    );
}