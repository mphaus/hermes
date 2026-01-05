import { Info } from "lucide-react";
import ProductSearchSelect from "./ProductSearchSelect";

export default function QuarantineProductField() {
    return (
        <div className="space-y-4">
            <p className="font-semibold">{ 'Product' }</p>
            <div className="flex items-start gap-1">
                <Info size={ 16 } className="text-secondary shrink-0" />
                <p className="text-xs">{ 'Type the first few letters of the Product and pause to let the system get info from CurrentRMS. Select the exact-match Product. If the Product cannot be found in this listing, double-check the spelling of the Product name (per the info plate on the equipment), then ask the SRMM Manager for advice on how to proceed.' }</p>
            </div>
            <ProductSearchSelect
                name="product_id"
                placeholder={ 'Search Products' }
                params={ {
                    'per_page': 20,
                    'q[name_cont]': '?',
                } }
            />
        </div>
    );
}
