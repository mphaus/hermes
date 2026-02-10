import Pagination from "@/_components/Pagination";
import UsersFab from "@/_components/UsersFab";
import UsersList from "@/_components/UsersList";
import UserCreateController from "@/actions/App/Http/Controllers/UserCreateController";
import { SharedData, UsersData } from "@/types";
import { Head, Link, usePage } from "@inertiajs/react";
import clsx from "clsx";
import { Plus } from "lucide-react";
import { useState } from "react";

export default function UserIndex() {
    const { title } = usePage<SharedData>().props;
    const usersData = usePage<SharedData>().props.users_data as UsersData;
    const { data: users, per_page, total, links } = usersData;
    const [userIsBeingDeleted, setUserIsBeingDeleted] = useState(false);


    return (
        <>
            <Head title={title} />
            <div className={clsx({
                'pointer-events-none opacity-50': userIsBeingDeleted,
            })}>
                <div className="hidden xl:flex xl:justify-end xl:mb-6">
                    <Link href={UserCreateController()} title={'Add new user'} className="btn btn-primary btn-outline btn-sm">
                        <Plus size={16} />
                        <span>{'Add new'}</span>
                    </Link>
                </div>
                <UsersList users={users} onUserIsBeingDeleted={() => setUserIsBeingDeleted(true)} />
                {per_page < total && (
                    <div className="mt-4">
                        <Pagination links={links} />
                    </div>
                )}
                <UsersFab />
            </div>
        </>
    );
}
