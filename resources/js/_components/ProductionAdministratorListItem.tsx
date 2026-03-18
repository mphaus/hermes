import ProductionAdministratorEditController from "@/actions/App/Http/Controllers/ProductionAdministratorEditController";
import { CurrentRMSListValue } from "@/types";
import { Link } from "@inertiajs/react";

export default function ProductionAdministratorListItem({
    productionAdministrator,
}: {
    productionAdministrator: CurrentRMSListValue;
}) {
    return (
        <li className="list-row">
            <Link
                href={ProductionAdministratorEditController(productionAdministrator.id)}
                title={productionAdministrator.name}
                className="after:absolute after:inset-0 after:z-1 after:content-['']"
            >
                {productionAdministrator.name}
            </Link>
        </li>
    );
}
