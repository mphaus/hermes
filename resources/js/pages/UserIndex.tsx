import UsersFab from "@/_components/UsersFab";
import UsersList from "@/_components/UsersList";
import { SharedData, UsersData } from "@/types";
import { Head, Link, usePage } from "@inertiajs/react";
import { Plus } from "lucide-react";

export default function UserIndex() {
    const { title } = usePage<SharedData>().props;
    const usersData = usePage<SharedData>().props.users_data as UsersData;
    const { data: users } = usersData;


    return (
        <>
            <Head title={title} />
            <div className="hidden xl:flex xl:justify-end xl:mb-6">
                <Link href="#" className="btn btn-primary btn-outline btn-sm">
                    <Plus size={16} />
                    <span>{'Add new'}</span>
                </Link>
            </div>
            <UsersList users={users} />
            <UsersFab />
        </>
    );
}
