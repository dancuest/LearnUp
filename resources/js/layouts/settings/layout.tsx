import Heading from '@/components/heading';
import { Button } from '@/components/ui/button';
import { Separator } from '@/components/ui/separator';
import { cn } from '@/lib/utils';
import { type NavItem } from '@/types';
import { Link } from '@inertiajs/react';
import { type PropsWithChildren } from 'react';

const sidebarNavItems: NavItem[] = [
    {
        title: 'Profile',
        url: '/settings/profile',
        icon: null,
    },
    {
        title: 'Password',
        url: '/settings/password',
        icon: null,
    },
    {
        title: 'Appearance',
        url: '/settings/appearance',
        icon: null,
    },
    {
        title: 'Image Upload',
        url: '/settings/image-upload',
        icon: null,
    }
];

export default function SettingsLayout({ children }: PropsWithChildren) {
    const currentPath = window.location.pathname;

    return (
        <div className="pages px-4 py-6 overflow-y-visible grid md:flex">
            <div className='Pages'>
                <Heading title="Settings" description="Manage your profile and account settings" />
                <aside className="w-full max-w-xl lg:w-48">
                    <nav className="flex flex-col space-y-1 space-x-0">
                        {sidebarNavItems.map((item) => (
                            <Button
                                key={item.url}
                                size="sm"
                                variant="ghost"
                                asChild
                                className={cn('w-full justify-start', {
                                    'bg-muted': currentPath === item.url,
                                })}
                            >
                                <Link href={item.url} prefetch>
                                    {item.title}
                                </Link>
                            </Button>
                        ))}
                    </nav>
                </aside>

                <Separator className="my-6 md:hidden" />
            <div className="border-b-blue-500 rounded-2xl p-6 p-6s shadow-xl flex-1 md:max-w-2xl">
                <section className=" space-y-12">{children}</section>
            </div>
        </div>
    );
}
