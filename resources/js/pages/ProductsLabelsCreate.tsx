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
    const ops_inventory_group_id = usePage<SharedData>().props.ops_inventory_group_id as number;
    const [products, setProducts] = useState<Product[]>([]);
    // const [products, setProducts] = useState<Product[]>([
    //     {
    //         "id": 2629,
    //         "name": "3M Respirator Multi-Purpose Quick Latch With Cool Flow Valve",
    //         "icon": {
    //             "thumb_url": "",
    //             "url": ""
    //         },
    //         "custom_fields": {
    //             "colour_coded_storage": "",
    //             "nally_bin_storage": "",
    //             "nally_bin_storage_stored_at_height": "",
    //             "tub_storage": "",
    //             "stock_unit": "Individual Item"
    //         }
    //     },
    //     {
    //         "id": 2630,
    //         "name": "3M Respirator Refill Cartridges 6500 - Pink",
    //         "icon": {
    //             "thumb_url": "",
    //             "url": ""
    //         },
    //         "custom_fields": {
    //             "colour_coded_storage": "",
    //             "nally_bin_storage": "",
    //             "nally_bin_storage_stored_at_height": "",
    //             "tub_storage": "",
    //             "stock_unit": "Individual Pairs"
    //         }
    //     },
    //     {
    //         "id": 2672,
    //         "name": "Accory Next Inspection Due Rigging Tags 175mm - Red",
    //         "icon": {
    //             "thumb_url": "",
    //             "url": ""
    //         },
    //         "custom_fields": {
    //             "colour_coded_storage": "No",
    //             "nally_bin_storage": "No",
    //             "nally_bin_storage_stored_at_height": "No",
    //             "tub_storage": "No",
    //             "stock_unit": "Pack of 1000"
    //         }
    //     },
    //     {
    //         "id": 2760,
    //         "name": "Action Labels MPH Equipment Branding Label 50x30mm - White on Black",
    //         "icon": {
    //             "thumb_url": "",
    //             "url": ""
    //         },
    //         "custom_fields": {
    //             "colour_coded_storage": "",
    //             "nally_bin_storage": "",
    //             "nally_bin_storage_stored_at_height": "",
    //             "tub_storage": "",
    //             "stock_unit": "Rolls of 500"
    //         }
    //     },
    //     {
    //         "id": 2798,
    //         "name": "All Set Jumbo Dustpan And Brush Set - Dark Green",
    //         "icon": {
    //             "thumb_url": "",
    //             "url": ""
    //         },
    //         "custom_fields": {
    //             "colour_coded_storage": "",
    //             "nally_bin_storage": "",
    //             "nally_bin_storage_stored_at_height": "",
    //             "tub_storage": "",
    //             "stock_unit": "Individual Item"
    //         }
    //     },
    //     {
    //         "id": 2655,
    //         "name": "Ambersil Anti Static Foaming Cleanser - 400ml",
    //         "icon": {
    //             "thumb_url": "",
    //             "url": ""
    //         },
    //         "custom_fields": {
    //             "colour_coded_storage": "",
    //             "nally_bin_storage": "",
    //             "nally_bin_storage_stored_at_height": "",
    //             "tub_storage": "",
    //             "stock_unit": "Individual Item"
    //         }
    //     },
    //     {
    //         "id": 2540,
    //         "name": "Antari Smoke Fluid For Fog Jet Super Fast Dissipating - 4L",
    //         "icon": {
    //             "thumb_url": "",
    //             "url": ""
    //         },
    //         "custom_fields": {
    //             "colour_coded_storage": "",
    //             "nally_bin_storage": "",
    //             "nally_bin_storage_stored_at_height": "",
    //             "tub_storage": "",
    //             "stock_unit": "NA"
    //         }
    //     },
    //     {
    //         "id": 2709,
    //         "name": "A Plus Plastics AP10 Stacking Nesting Crate 645x413x276mm 52L - Blue",
    //         "icon": {
    //             "thumb_url": "",
    //             "url": ""
    //         },
    //         "custom_fields": {
    //             "colour_coded_storage": "",
    //             "nally_bin_storage": "",
    //             "nally_bin_storage_stored_at_height": "",
    //             "tub_storage": "",
    //             "stock_unit": "Individual Item"
    //         }
    //     },
    //     {
    //         "id": 2710,
    //         "name": "A Plus Plastics AP10 Stacking Nesting Crate 645x413x276mm 52L - Green",
    //         "icon": {
    //             "thumb_url": "",
    //             "url": ""
    //         },
    //         "custom_fields": {
    //             "colour_coded_storage": "",
    //             "nally_bin_storage": "",
    //             "nally_bin_storage_stored_at_height": "",
    //             "tub_storage": "",
    //             "stock_unit": "Individual Item"
    //         }
    //     },
    //     {
    //         "id": 2712,
    //         "name": "A Plus Plastics AP10 Stacking Nesting Crate 645x413x276mm 52L - Grey",
    //         "icon": {
    //             "thumb_url": "",
    //             "url": ""
    //         },
    //         "custom_fields": {
    //             "colour_coded_storage": "",
    //             "nally_bin_storage": "",
    //             "nally_bin_storage_stored_at_height": "",
    //             "tub_storage": "",
    //             "stock_unit": "Individual Item"
    //         }
    //     },
    //     {
    //         "id": 2707,
    //         "name": "A Plus Plastics AP10 Stacking Nesting Crate 645x413x276mm 52L - Red",
    //         "icon": {
    //             "thumb_url": "",
    //             "url": ""
    //         },
    //         "custom_fields": {
    //             "colour_coded_storage": "",
    //             "nally_bin_storage": "",
    //             "nally_bin_storage_stored_at_height": "",
    //             "tub_storage": "",
    //             "stock_unit": "Individual Item"
    //         }
    //     },
    //     {
    //         "id": 2708,
    //         "name": "A Plus Plastics AP10 Stacking Nesting Crate 645x413x276mm 52L - Yellow",
    //         "icon": {
    //             "thumb_url": "",
    //             "url": ""
    //         },
    //         "custom_fields": {
    //             "colour_coded_storage": "",
    //             "nally_bin_storage": "",
    //             "nally_bin_storage_stored_at_height": "",
    //             "tub_storage": "",
    //             "stock_unit": "Individual Item"
    //         }
    //     },
    //     {
    //         "id": 2706,
    //         "name": "A Plus Plastics APOES Enviro Skate 615x405x190mm - Black",
    //         "icon": {
    //             "thumb_url": "",
    //             "url": ""
    //         },
    //         "custom_fields": {
    //             "colour_coded_storage": "",
    //             "nally_bin_storage": "",
    //             "nally_bin_storage_stored_at_height": "",
    //             "tub_storage": "",
    //             "stock_unit": "Individual Item"
    //         }
    //     },
    //     {
    //         "id": 2693,
    //         "name": "Aussie Pallets Generic Wooden Pallet - 1200x1200mm",
    //         "icon": {
    //             "thumb_url": "",
    //             "url": ""
    //         },
    //         "custom_fields": {
    //             "colour_coded_storage": "",
    //             "nally_bin_storage": "",
    //             "nally_bin_storage_stored_at_height": "",
    //             "tub_storage": "",
    //             "stock_unit": "Individual Item"
    //         }
    //     },
    //     {
    //         "id": 2692,
    //         "name": "Aussie Pallets MPH-Branded Pallet - 1200x1200mm",
    //         "icon": {
    //             "thumb_url": "",
    //             "url": ""
    //         },
    //         "custom_fields": {
    //             "colour_coded_storage": "",
    //             "nally_bin_storage": "",
    //             "nally_bin_storage_stored_at_height": "",
    //             "tub_storage": "",
    //             "stock_unit": "Individual Item"
    //         }
    //     },
    //     {
    //         "id": 2742,
    //         "name": "Avery Blank Lables Heavy Duty White Polyester Laser Rectangle 139x99.1mm - 4up",
    //         "icon": {
    //             "thumb_url": "",
    //             "url": ""
    //         },
    //         "custom_fields": {
    //             "colour_coded_storage": "",
    //             "nally_bin_storage": "",
    //             "nally_bin_storage_stored_at_height": "",
    //             "tub_storage": "",
    //             "stock_unit": "Pack of 100"
    //         }
    //     },
    //     {
    //         "id": 2743,
    //         "name": "Avery Blank Lables Heavy Duty White Polyester Laser Rectangle 190x16mm - 12up",
    //         "icon": {
    //             "thumb_url": "",
    //             "url": ""
    //         },
    //         "custom_fields": {
    //             "colour_coded_storage": "",
    //             "nally_bin_storage": "",
    //             "nally_bin_storage_stored_at_height": "",
    //             "tub_storage": "",
    //             "stock_unit": "Pack of 100"
    //         }
    //     },
    //     {
    //         "id": 2741,
    //         "name": "Avery Blank Lables Heavy Duty White Polyester Laser Rectangle 210x148mm - 2up",
    //         "icon": {
    //             "thumb_url": "",
    //             "url": ""
    //         },
    //         "custom_fields": {
    //             "colour_coded_storage": "",
    //             "nally_bin_storage": "",
    //             "nally_bin_storage_stored_at_height": "",
    //             "tub_storage": "",
    //             "stock_unit": "Pack of 100"
    //         }
    //     },
    //     {
    //         "id": 2740,
    //         "name": "Avery Blank Lables Heavy Duty White Polyester Laser Rectangle 297x210mm - A4",
    //         "icon": {
    //             "thumb_url": "",
    //             "url": ""
    //         },
    //         "custom_fields": {
    //             "colour_coded_storage": "",
    //             "nally_bin_storage": "",
    //             "nally_bin_storage_stored_at_height": "",
    //             "tub_storage": "",
    //             "stock_unit": "Pack of 200"
    //         }
    //     },
    //     {
    //         "id": 2739,
    //         "name": "Avery Blank Lables Heavy Duty White Polyester Laser Rectangle 70x36mm - 24up",
    //         "icon": {
    //             "thumb_url": "",
    //             "url": ""
    //         },
    //         "custom_fields": {
    //             "colour_coded_storage": "",
    //             "nally_bin_storage": "",
    //             "nally_bin_storage_stored_at_height": "",
    //             "tub_storage": "",
    //             "stock_unit": "Pack of 200"
    //         }
    //     }
    // ]);
    const [processing, setProcessing] = useState(false);
    const [generateForOpsInventoryGroup, setGenerateForOpsInventoryGroup] = useState(false);
    const hasProductsWithNoCustomFields = !generateForOpsInventoryGroup && products.some(productHasNoCustomFields);

    const productSearchParams = {
        'per_page': 20,
        'q[name_cont]': '?',
        ...(generateForOpsInventoryGroup && {
            'q[product_group_id_eq]': ops_inventory_group_id,
        })
    };

    const handleGenerateForOpsInventoryGroupChange = (checked: boolean) => {
        setGenerateForOpsInventoryGroup(checked);

        if (products.length > 0) {
            setProducts([]);
        }
    };

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

        router.post(ProductsLabelsGenerateController().url, { products, generate_for_ops_inventory_group: generateForOpsInventoryGroup }, {
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
                        key={generateForOpsInventoryGroup ? 'ops-inventoy' : 'all-products'}
                        name="product"
                        placeholder="Search for products..."
                        clearOnSelect
                        params={productSearchParams}
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
                        <div className="flex-1 min-h-0 overflow-y-auto max-h-[calc(100dvh-19.5rem)] rounded-b-lg md:max-h-[calc(100dvh-10.5rem)]">
                            <ProductList
                                products={products}
                                onClear={() => setProducts([])}
                                onRemove={handleRemoveProduct}
                                ignoreMissingCustomFields={generateForOpsInventoryGroup}
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
                        checked={generateForOpsInventoryGroup}
                        onCheckedChange={handleGenerateForOpsInventoryGroupChange}
                        onGenerate={handleGenerateLabels}
                    />
                </div>
            </div>
            {/* <div className="h-48"></div> */}
            <ProductFloatingGenerateLabels
                processing={processing}
                disabled={products.length === 0}
                checked={generateForOpsInventoryGroup}
                onCheckedChange={handleGenerateForOpsInventoryGroupChange}
                onGenerate={handleGenerateLabels}
            />
        </>
    );
}