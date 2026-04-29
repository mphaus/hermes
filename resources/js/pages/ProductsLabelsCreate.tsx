import ProductList from "@/_components/ProductList";
import ProductSearchSelect, { ProductOption } from "@/_components/ProductSearchSelect";
import { Product, SharedData } from "@/types";
import { Head, usePage } from "@inertiajs/react";
import { Printer, X } from "lucide-react";
import { useState } from "react";

export default function ProductsLabelsCreate() {
    const { title } = usePage<SharedData>().props;
    const [products, setProducts] = useState<Product[]>([]);

    const handleProductSearchSelectChange = (option: ProductOption | null) => {
        if (option) {
            setProducts(prevProducts => [...prevProducts, option.product]);
        }
    };

    return (
        <>
            <Head title={title} />
            <div className="md:grid md:gap-4 md:grid-cols-3 md:items-start xl:grid-cols-4">
                <div className="space-y-4 md:col-span-2 xl:col-span-3">
                    <ProductSearchSelect
                        name="product"
                        placeholder="Search for products..."
                        clearOnSelect
                        params={{
                            'per_page': 20,
                            'q[name_cont]': '?',
                        }}
                        onChange={handleProductSearchSelectChange}
                    />
                    {products.length > 0 ? (
                        <ProductList products={products} />
                    ) : (
                        <div className="alert alert-info alert-soft">{'No products have been selected. Search for and select products to generate labels.'}</div>
                    )}
                </div>
                <div className="hidden shadow-sm card bg-base-100 md:block card-sm">
                    <div className="card-body">
                        <h2 className="card-title">{'Generate'}</h2>
                        <p>{'According to the product specifications in CurrentRMS, four types of labels can be generated:'}</p>
                        <ul className="pl-10 font-semibold list-disc">
                            <li>{'Tub labels'}</li>
                            <li>{'Nally bin labels - Standard'}</li>
                            <li>{'Nally bin labels - Stored at height'}</li>
                            <li>{'Colour-coded labels'}</li>
                        </ul>
                        <button type="button" className="mt-4 btn btn-primary btn-block">
                            <Printer size={16} />
                            <span>{'Generate labels'}</span>
                        </button>
                    </div>
                </div>
            </div>
            <div className="fixed z-10 inset-x-4 bottom-4 md:hidden">
                <button type="button" className="btn btn-primary btn-lg btn-block">
                    <Printer size={16} />
                    <span>{'Generate labels'}</span>
                </button>
            </div>
        </>
    );
}