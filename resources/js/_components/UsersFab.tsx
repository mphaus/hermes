import UsersCreateController from "@/actions/App/Http/Controllers/UsersCreateController";
import { Link } from "@inertiajs/react";
import { Plus } from "lucide-react";

export default function UsersFab() {
    return (
        <div className="fab xl:hidden">
            <Link
                href={UsersCreateController()}
                className="btn btn-lg btn-circle btn-primary"
                title={'Add new user'}
            >
                <Plus size={16} />
            </Link>
        </div>
    );
}
