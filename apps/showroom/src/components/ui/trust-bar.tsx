import { Truck, ShieldCheck, Headphones, CreditCard } from 'lucide-react';

const trustItems = [
  {
    icon: Truck,
    title: 'Livraison Rapide',
    description: 'Partout en Côte d\'Ivoire',
  },
  {
    icon: ShieldCheck,
    title: 'Garantie Officielle',
    description: 'Produits 100% authentiques',
  },
  {
    icon: Headphones,
    title: 'Support Expert',
    description: 'Conseils techniques dédiés',
  },
  {
    icon: CreditCard,
    title: 'Paiement Sécurisé',
    description: 'Mobile Money & Carte',
  },
];

export function TrustBar() {
  return (
    <div className="border-y bg-gray-50/50">
      <div className="container py-8">
        <div className="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
          {trustItems.map((item, index) => (
            <div key={index} className="flex items-center space-x-4">
              <div className="flex h-12 w-12 items-center justify-center rounded-full bg-primary/10 text-primary">
                <item.icon className="h-6 w-6" />
              </div>
              <div>
                <h3 className="font-semibold text-gray-900">{item.title}</h3>
                <p className="text-sm text-muted-foreground">{item.description}</p>
              </div>
            </div>
          ))}
        </div>
      </div>
    </div>
  );
}
