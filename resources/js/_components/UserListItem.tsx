import { User } from "@/types";
import { Link } from "@inertiajs/react";
import { PenLine, Trash2 } from "lucide-react";

export default function UserListItem({ user }: {
    user: User;
}) {
    return (
        <div className="card card-sm bg-base-100 shadow-sm">
            <div className="card-body">
                <div className="grid gap-4 md:grid-cols-6 sm:items-center sm:text-center">
                    <div className="space-y-1">
                        <p className="font-semibold sm:hidden">{'Name'}</p>
                        <Link href={'#'} className="font-semibold">{user.first_name} {user.last_name}</Link>
                    </div>
                    <div className="space-y-1">
                        <p className="font-semibold sm:hidden">{'Username'}</p>
                        <p>{user.username}</p>
                    </div>
                    <div className="space-y-1">
                        <p className="font-semibold sm:hidden">{'Email'}</p>
                        <p>{user.email}</p>
                    </div>
                    <div className="space-y-1">
                        <p className="font-semibold sm:hidden">{'Is admin'}</p>
                        {user.is_admin ? (
                            <span className="badge badge-success badge-sm font-semibold">Yes</span>
                        ) : (
                            <span className="badge badge-error badge-sm font-semibold">No</span>
                        )}
                    </div>
                    <div className="space-y-1">
                        <p className="font-semibold sm:hidden">{'Is enabled'}</p>
                        {user.is_enabled ? (
                            <span className="badge badge-success badge-sm font-semibold">Yes</span>
                        ) : (
                            <span className="badge badge-error badge-sm font-semibold">No</span>
                        )}
                    </div>
                    <div className="flex items-center justify-end gap-1 sm:justify-center">
                        <a href="#" title={'Edit'} className="btn btn-ghost btn-primary btn-sm">
                            <PenLine size={16} />
                        </a>
                        <button type="button" title={'Delete'} className="btn btn-ghost btn-error btn-sm">
                            <Trash2 size={16} />
                        </button>
                    </div>
                </div>
            </div>
        </div>
    );
}
