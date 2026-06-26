import ProductFloatingGenerateLabels from "@/_components/ProductFloatingGenerateLabels";
import ProductGenerateLabels from "@/_components/ProductGenerateLabels";
import ProductList from "@/_components/ProductList";
import ProductSearchSelect, { ProductOption } from "@/_components/ProductSearchSelect";
import ProductsLabelsGenerateController from "@/actions/App/Http/Controllers/ProductsLabelsGenerateController";
import { Product, SharedData } from "@/types";
import productHasNoCustomFields from "@/utils/productHasNoCustomFields";
import { Head, router, usePage } from "@inertiajs/react";
import { useState } from "react";

export default function ProductsLabelsCreate() {
    const { title, errors } = usePage<SharedData>().props;
    const [products, setProducts] = useState<Product[]>([]);
    const [processing, setProcessing] = useState(false);
    const hasProductsWithNoCustomFields = products.some(productHasNoCustomFields);

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

    const handleGenerateLabels = () => {
        setProcessing(true);
        router.post(ProductsLabelsGenerateController().url, { products }, {
            onError() {
                setProcessing(false);
            },
        });
    };

    return (
        <>
            <Head title={title} />
            <div className="md:grid md:gap-4 md:grid-cols-3 md:items-stretch xl:grid-cols-4">
                <div className="space-y-4 md:col-span-2 xl:col-span-3 md:flex md:flex-col md:min-h-0">
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
                    {errors.products && (
                        <div
                            role="alert"
                            className="alert alert-error alert-soft block"
                            dangerouslySetInnerHTML={{ __html: errors.products }}
                        ></div>
                    )}
                    {hasProductsWithNoCustomFields && (
                        <div role="alert" className="alert alert-warning alert-soft">
                            {'You have selected one or more products that are not configured for label generation (highlighted in red). Labels for these products will not be generated. If you believe labels should be available for these products, please contact your supervisor to have the product settings reviewed'}
                        </div>
                    )}
                    {products.length > 0 ? (
                        <div className="flex-1 min-h-0 overflow-y-auto max-h-[calc(100dvh-14rem)] rounded-b-lg md:max-h-[calc(100dvh-10.5rem)]">
                            <ProductList
                                products={products}
                                onClear={() => setProducts([])}
                                onRemove={handleRemoveProduct}
                            />
                        </div>
                    ) : (
                        <div className="alert alert-info alert-soft">{'No products have been selected. Search for and select products to generate labels.'}</div>
                    )}
                </div>
                <div className="place-self-start">
                    <ProductGenerateLabels
                        processing={processing}
                        disabled={products.length === 0}
                        onGenerate={handleGenerateLabels}
                    />
                </div>
            </div>
            <ProductFloatingGenerateLabels
                processing={processing}
                disabled={products.length === 0}
                onGenerate={handleGenerateLabels}
            />
        </>
    );
}