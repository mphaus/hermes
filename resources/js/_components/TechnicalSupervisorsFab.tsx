import TechnicalSupervisorCreateController from "@/actions/App/Http/Controllers/TechnicalSupervisorCreateController";
import { Link } from "@inertiajs/react";
import { Plus } from "lucide-react";

export default function TechnicalSupervisorsFab() {
    return (
        <div className="fab xl:hidden">
            <Link
                href={TechnicalSupervisorCreateController()}
                className="btn btn-lg btn-circle btn-primary"
                title={'Add new technical supervisor'}
            >
                <Plus size={16} />
            </Link>
        </div>
    );
}