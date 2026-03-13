import ProductionAdministratorsFab from "@/_components/ProductionAdministratorsFab";
import ProductionAdministratorSkeleton from "@/_components/ProductionAdministratorSkeleton";
import ProductionAdministratorsList from "@/_components/ProductionAdministratorsList";
import { CurrentRMSListValue, SharedData } from "@/types";
import { Deferred, Head, Link, usePage } from "@inertiajs/react";
import { Plus } from "lucide-react";

export default function ProductionAdministratorIndex() {
    const { title } = usePage<SharedData>().props;
    const productionAdministratorsData = usePage<SharedData>().props
        .production_administrators_data as
        | {
            error: string;
            data: CurrentRMSListValue[];
        }
        | undefined;
    const { error, data: productionAdministrators } =
        productionAdministratorsData || {};

    return (
        <>
            <Head title={title} />
            <Deferred
                data="production_administrators_data"
                fallback={<ProductionAdministratorSkeleton />}
            >
                {error && (
                    <div role="alert" className="alert alert-error">
                        {error}
                    </div>
                )}
                <>
                    <div className="hidden xl:flex xl:justify-end xl:mb-6">
                        <Link
                            href="/production-administrators/create"
                            title="Add new production administrator"
                            className="btn btn-primary btn-outline btn-sm"
                        >
                            <Plus size={16} />
                            <span>{'Add new'}</span>
                        </Link>
                    </div>
                    {!productionAdministrators?.length && (
                        <div
                            role="alert"
                            className="alert alert-info max-w-3xl mx-auto"
                        >
                            {'You have not added any Production Administrators yet.'}
                        </div>
                    )}
                    {!!productionAdministrators?.length && (
                        <ProductionAdministratorsList
                            productionAdministrators={productionAdministrators}
                        />
                    )}
                    <ProductionAdministratorsFab />
                </>
            </Deferred>
        </>
    );
}
