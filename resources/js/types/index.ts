import { LucideIcon } from 'lucide-react';
import { PageProps as InertiaPageProps } from "@inertiajs/core";

export interface Auth {
    user: User;
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavGroup {
    title: string;
    items: NavItem[];
}

export interface NavItem {
    title: string;
    url: string;
    icon?: LucideIcon | null;
    isActive?: boolean;
}

export interface SharedData {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
    [key: string]: unknown;
}

export interface User {
    id: number;
    name: string;
    email: string;
    imagen_perfil?: string;
}
export interface PageProps extends InertiaPageProps {
    auth?: {
        user?: User;
    };
}

export interface Institution {
    id: number;
    nombre: string;
    descripcion: string;
    tipo: string;
    capacidad: number;
    capacidad_limite: boolean;
    imagen_perfil: string;
    user_id: number;
    creador?: {
        id: number;
        name: string;
        email: string;
    };
    miembros?: {
        id: number;
        name: string;
        rol: string;
        estado: string;
        estado_pago: string;
        fecha_pago: string;
    }[];
    cursos?: {
        id: number;
        nombre: string;
        descripcion: string;
    }[];
    planes?: {
        id: number;
        nombre: string;
        fecha_inicio: string;
        fecha_fin: string;
        estado: string;
        renovacion_automatica: boolean;
    }[];
    pagos?: {
        id: number;
        amount: number;
        date: string;
    }[];
}
