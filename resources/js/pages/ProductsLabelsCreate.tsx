import ProductFloatingGenerateLabels from "@/_components/ProductFloatingGenerateLabels";
import ProductGenerateLabels from "@/_components/ProductGenerateLabels";
import ProductList from "@/_components/ProductList";
import ProductSearchSelect, { ProductOption } from "@/_components/ProductSearchSelect";
import { Product, SharedData } from "@/types";
import { Head, usePage } from "@inertiajs/react";
import { Printer } from "lucide-react";
import { useState } from "react";

export default function ProductsLabelsCreate() {
    const { title } = usePage<SharedData>().props;
    const [products, setProducts] = useState<Product[]>([]);

    const handleProductSearchSelectChange = (option: ProductOption | null) => {
        if (option) {
            setProducts(prevProducts => {
                if (prevProducts.some(product => product.id === option.product.id)) {
                    return prevProducts;
                }

                return [...prevProducts, option.product];
            });
        }
    };

    const handleRemoveProduct = (productId: number) => {
        setProducts(prevProducts => prevProducts.filter(product => product.id !== productId));
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
                        <ProductList
                            products={products}
                            onClear={() => setProducts([])}
                            onRemove={handleRemoveProduct}
                        />
                    ) : (
                        <div className="alert alert-info alert-soft">{'No products have been selected. Search for and select products to generate labels.'}</div>
                    )}
                </div>
                <ProductGenerateLabels disabled={products.length === 0} />
            </div>
            <ProductFloatingGenerateLabels disabled={products.length === 0} />
        </>
    );
}