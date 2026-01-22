import { Link } from "@inertiajs/react";
import { Plus } from "lucide-react";

export default function UsersFab() {
    return (
        <div className="fab xl:hidden">
            <Link href="#" className="btn btn-lg btn-circle btn-primary">
                <Plus size={16} />
            </Link>
        </div>
    );
}
