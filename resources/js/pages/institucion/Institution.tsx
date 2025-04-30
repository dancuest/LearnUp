import { useParams } from 'react-router-dom';

export function Institution() {
    const { institution } = useParams<{ institution: string }>();

    return (
        <div>
            <h1>Institution ID: {institution}</h1>
        </div>
    );
}