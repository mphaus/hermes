import UserShowController from "@/actions/App/Http/Controllers/UserShowController";
import UserEditController from "@/actions/App/Http/Controllers/UserEditController";
import { SharedData, User } from "@/types";
import { Link, usePage } from "@inertiajs/react";
import { PenLine, Trash2 } from "lucide-react";

export default function UserListItem({ user, onDelete }: {
    user: User;
    onDelete: (user: User) => void;
}) {
    const { auth } = usePage<SharedData>().props;
    const isCurrentUser = auth.user?.id === user.id;

    return (
        <li className="list-row grid-cols-1">
            <div className="flex flex-col gap-4 lg:text-center lg:grid lg:grid-cols-10 lg:items-center">
                <div className="space-y-1 lg:col-span-2">
                    <p className="font-semibold lg:hidden">{'Name'}</p>
                    <Link href={UserShowController(user.id)} className="font-semibold text-primary">{user.first_name} {user.last_name}</Link>
                </div>
                <div className="space-y-1 lg:col-span-2">
                    <p className="font-semibold lg:hidden">{'Username'}</p>
                    <p>{user.username}</p>
                </div>
                <div className="space-y-1 lg:col-span-3">
                    <p className="font-semibold lg:hidden">{'Email'}</p>
                    <p>{user.email}</p>
                </div>
                <div className="space-y-1">
                    <p className="font-semibold lg:hidden">{'Is admin'}</p>
                    {user.is_admin ? (
                        <span className="badge badge-success badge-sm font-semibold">Y</span>
                    ) : (
                        <span className="badge badge-error badge-sm font-semibold">N</span>
                    )}
                </div>
                <div className="space-y-1">
                    <p className="font-semibold lg:hidden">{'Is enabled'}</p>
                    {user.is_enabled ? (
                        <span className="badge badge-success badge-sm font-semibold">Y</span>
                    ) : (
                        <span className="badge badge-error badge-sm font-semibold">N</span>
                    )}
                </div>
                {!isCurrentUser && (
                    <div className="flex items-center justify-end gap-1 md:justify-end lg:justify-center">
                        <Link href={UserEditController(user.id)} title={'Edit'} className="btn btn-ghost btn-primary btn-sm">
                            <PenLine size={16} />
                        </Link>
                        <button
                            type="button"
                            title={'Delete'}
                            className="btn btn-ghost btn-error btn-sm"
                            onClick={() => onDelete(user)}
                        >
                            <Trash2 size={16} />
                        </button>
                    </div>
                )}
            </div>
        </li>
    );
}
