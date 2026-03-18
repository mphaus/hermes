import { CurrentRMSListValue } from "@/types";
import ProductionAdministratorListItem from "./ProductionAdministratorListItem";

export default function ProductionAdministratorsList({
    productionAdministrators,
}: {
    productionAdministrators: CurrentRMSListValue[];
}) {
    return (
        <ul className="list bg-base-100 rounded-lg shadow-sm max-w-xl mx-auto">
            {productionAdministrators.map((productionAdministrator) => (
                <ProductionAdministratorListItem
                    key={productionAdministrator.id}
                    productionAdministrator={productionAdministrator}
                />
            ))}
        </ul>
    );
}
