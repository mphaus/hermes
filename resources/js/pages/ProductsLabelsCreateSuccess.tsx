import ProductsLabelsCreateController from "@/actions/App/Http/Controllers/ProductsLabelsCreateController";
import { SharedData } from "@/types";
import { Head, Link, router, usePage } from "@inertiajs/react";

export default function ProductsLabelsCreateSuccess() {
    const { title } = usePage<SharedData>().props;
    const product_labels_download = usePage<SharedData>().props.product_labels_download as { url: string, filename: string };

    return (
        <>
            <Head title={title} />
            <div className="mx-auto max-w-3xl">
                <div className="card bg-base-100 shadow-sm">
                    <div className="card-body gap-6">
                        <div className="flex items-center justify-center">
                            <div className="inline-flex items-center gap-2 rounded-full border border-success/30 bg-success/10 px-4 py-2 text-xs font-bold uppercase text-success-content sm:text-sm">
                                <span className="inline-block h-2 w-2 rounded-full bg-success"></span>
                                {'Success'}
                            </div>
                        </div>
                        <div className="space-y-3 text-center">
                            <h1 className="text-2xl font-bold leading-tight sm:text-3xl lg:text-4xl">
                                {'Product labels have been generated successfully.'}
                            </h1>
                            <p className="mx-auto max-w-2xl text-base-content/75 sm:text-lg">
                                {'Click the button below to download your product labels or generate new ones.'}
                            </p>
                        </div>
                        <div className="grid grid-cols-1 gap-3 pt-2 sm:grid-cols-2 sm:gap-4">
                            <a
                                href={product_labels_download.url}
                                download={product_labels_download.filename}
                                className="btn btn-primary btn-lg w-full"
                            >
                                {'Download Labels'}
                            </a>
                            <Link
                                href={ProductsLabelsCreateController().url}
                                className="btn btn-primary btn-soft btn-lg w-full"
                            >
                                {'Generate New Labels'}
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
}