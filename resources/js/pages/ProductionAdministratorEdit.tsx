import { Deferred, Head } from "@inertiajs/react";
import { SharedData } from "@/types";
import { usePage } from "@inertiajs/react";
import ProductionAdministratorEditSkeleton from "@/_components/ProductionAdministratorEditSkeleton";
import ProductionAdministratorForm from "@/_components/ProductionAdministratorForm";

export default function ProductionAdministratorEdit() {
    const { title } = usePage<SharedData>().props;
    const productionAdministratorData = usePage<SharedData>().props.production_administrator as
        | {
            error: string;
            data: {
                id: number;
                first_name: string;
                last_name: string;
            };
        }
        | undefined;

    const { error, data: productionAdministrator } = productionAdministratorData || {};

    return (
        <>
            <Head title={title} />
            <Deferred
                data="production_administrator"
                fallback={<ProductionAdministratorEditSkeleton />}
            >
                {error && (
                    <div role="alert" className="alert alert-error">
                        {error}
                    </div>
                )}
                {productionAdministrator && (
                    <ProductionAdministratorForm
                        productionAdministrator={productionAdministrator}
                    />
                )}
            </Deferred>
        </>
    );
}
