import UserDeleteConfirmDialog from "@/_components/UserDeleteConfirmDialog";
import UserEditController from "@/actions/App/Http/Controllers/UserEditController";
import UserDestroyController from "@/actions/App/Http/Controllers/UserDestroyController";
import { SharedData, User } from "@/types";
import { Head, Link, router, usePage } from "@inertiajs/react";
import { useState } from "react";
import clsx from "clsx";

export default function UserShow() {
    const user = usePage<SharedData>().props.user as User;
    const permissions = usePage<SharedData>().props.permissions as { value: string, label: string }[];
    const { auth } = usePage<SharedData>().props;
    const isCurrentUser = auth.user?.id === user.id;
    const [open, setOpen] = useState(false);
    const [userIsBeingDeleted, setUserIsBeingDeleted] = useState(false);

    const handleDeleteCancel = () => {
        setOpen(false);
    }

    const handleDeleteOk = () => {
        setOpen(false);
        setUserIsBeingDeleted(true);
        router.delete(UserDestroyController(user.id));
    }

    return (
        <>
            <Head title={`${user.first_name} ${user.last_name}`} />
            <div className={clsx({
                'grid gap-4 lg:grid-cols-3 lg:items-start': true,
                'pointer-events-none opacity-50': userIsBeingDeleted,
            })}>
                <div className="card bg-base-100 shadow-sm lg:col-span-2">
                    <div className="card-body">
                        <div className="grid gap-4 sm:grid-cols-2">
                            <div className="space-y-4">
                                <div className="space-y-1">
                                    <p className="text-sm font-semibold">{'User system number:'}</p>
                                    <p className="text-sm">{user.id}</p>
                                </div>
                                <div className="space-y-1">
                                    <p className="text-sm font-semibold">{'Username:'}</p>
                                    <p className="text-sm">{user.username}</p>
                                </div>
                                <div className="space-y-1">
                                    <p className="text-sm font-semibold">{'Email:'}</p>
                                    <p className="text-sm">{user.email}</p>
                                </div>
                                <div className="space-y-1">
                                    <p className="text-sm font-semibold">{'Is admin:'}</p>
                                    <p>
                                        {user.is_admin ? (
                                            <span className="badge badge-success badge-sm font-semibold">Yes</span>
                                        ) : (
                                            <span className="badge badge-error badge-sm font-semibold">No</span>
                                        )}
                                    </p>
                                </div>
                                <div className="space-y-1">
                                    <p className="text-sm font-semibold">{'Is enabled:'}</p>
                                    <p>
                                        {user.is_enabled ? (
                                            <span className="badge badge-success badge-sm font-semibold">Yes</span>
                                        ) : (
                                            <span className="badge badge-error badge-sm font-semibold">No</span>
                                        )}
                                    </p>
                                </div>
                            </div>
                            <div className="space-y-1">
                                <p className="text-sm font-semibold">{'Permissions:'}</p>
                                {user.is_admin ? (
                                    <p className="text-sm">{'All permissions granted'}</p>
                                ) : (
                                    <ul className="space-y-1 text-sm">
                                        {user.permissions.map((permission) => (
                                            <li key={permission}>{permissions.find((p) => p.value === permission)?.label}</li>
                                        ))}
                                    </ul>
                                )}
                            </div>
                        </div>
                    </div>
                </div>
                {!isCurrentUser && (
                    <div className="card bg-base-100 shadow-sm">
                        <div className="card-body">
                            <h2 className="card-title">{'Actions'}</h2>
                            <ul className="space-y-2">
                                <li>
                                    <Link href={'#'} className="font-semibold">{'Change user password'}</Link>
                                </li>
                                <li>
                                    <Link href={UserEditController(user.id)} className="font-semibold">{'Edit this user'}</Link>
                                </li>
                                <li>
                                    <button type="button" className="font-semibold cursor-pointer" onClick={() => setOpen(true)}>{'Delete this user'}</button>
                                </li>
                            </ul>
                        </div>
                    </div>
                )}
            </div>
            <UserDeleteConfirmDialog
                open={open}
                user={user}
                onCancel={handleDeleteCancel}
                onOk={handleDeleteOk}
            />
        </>
    );
}
