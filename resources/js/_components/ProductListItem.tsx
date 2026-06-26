import { Product } from "@/types";
import productHasNoCustomFields from "@/utils/productHasNoCustomFields";
import clsx from "clsx";
import { X } from "lucide-react";

export default function ProductListItem({ product, onRemove }: {
    product: Product;
    onRemove?: (productId: number) => void;
}) {
    const hasNoCustomFields = productHasNoCustomFields(product);

    return (
        <li className={clsx({
            'items-center list-row': true,
            'bg-red-200': hasNoCustomFields,
        })}>
            <div><img className="size-10 rounded-box" src={product.icon?.thumb_url || 'https://placehold.co/40x40?text=No+image'} alt={product.name} /></div>
            <div>{product.name}</div>
            <button type="button" className="btn btn-square btn-ghost" onClick={() => onRemove?.(product.id)}>
                <X size={16} />
            </button>
        </li>
    );
}