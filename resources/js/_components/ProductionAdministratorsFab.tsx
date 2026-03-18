import { Link } from "@inertiajs/react";
import { Plus } from "lucide-react";

export default function ProductionAdministratorsFab() {
    return (
        <div className="fab xl:hidden">
            <Link
                href="/production-administrators/create"
                className="btn btn-lg btn-circle btn-primary"
                title="Add new production administrator"
            >
                <Plus size={16} />
            </Link>
        </div>
    );
}
