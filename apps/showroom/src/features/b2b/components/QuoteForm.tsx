'use client';

import { useState } from 'react';
import { fetchAPI } from '@/lib/api';
import { Loader2, CheckCircle, AlertCircle } from 'lucide-react';

export function QuoteForm() {
  const [isLoading, setIsLoading] = useState(false);
  const [success, setSuccess] = useState(false);
  const [error, setError] = useState<string | null>(null);

  async function handleSubmit(event: React.FormEvent<HTMLFormElement>) {
    event.preventDefault();
    setIsLoading(true);
    setError(null);

    const formData = new FormData(event.currentTarget);
    const data = Object.fromEntries(formData.entries());

    try {
      await fetchAPI('leads/quote', {
        method: 'POST',
        body: JSON.stringify(data),
      });
      setSuccess(true);
    } catch (err) {
      setError('Une erreur est survenue. Veuillez réessayer plus tard.');
    } finally {
      setIsLoading(false);
    }
  }

  if (success) {
    return (
      <div className="bg-green-50 dark:bg-green-900/30 p-6 rounded-lg text-center">
        <div className="flex justify-center mb-4">
          <CheckCircle className="w-12 h-12 text-green-600 dark:text-green-400" />
        </div>
        <h3 className="text-xl font-bold text-green-800 dark:text-green-200 mb-2">Demande envoyée !</h3>
        <p className="text-green-700 dark:text-green-300">
          Nos experts ont bien reçu votre demande de devis. Vous serez contacté sous 24h ouvrées.
        </p>
      </div>
    );
  }

  return (
    <div className="bg-white dark:bg-zinc-900 p-6 md:p-8 rounded-lg shadow-md border border-gray-200 dark:border-gray-800">
      <div className="mb-6">
        <h2 className="text-2xl font-bold text-gray-900 dark:text-gray-100">Demande de Devis PRO</h2>
        <p className="text-gray-600 dark:text-gray-400 mt-2">
          Vous êtes une entreprise ? Obtenez une offre personnalisée adaptée à vos besoins techniques et volumétriques.
        </p>
      </div>

      {error && (
        <div className="bg-red-50 dark:bg-red-900/30 p-4 rounded-md flex items-center gap-3 text-red-800 dark:text-red-200 mb-6">
          <AlertCircle className="w-5 h-5 flex-shrink-0" />
          <p>{error}</p>
        </div>
      )}

      <form onSubmit={handleSubmit} className="space-y-4">
        <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div className="space-y-2">
            <label htmlFor="company" className="text-sm font-medium text-gray-700 dark:text-gray-300">
              Société *
            </label>
            <input
              id="company"
              name="company"
              required
              className="w-full rounded-md border border-gray-300 dark:border-gray-700 bg-transparent px-3 py-2 text-sm placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-black dark:focus:ring-white"
              placeholder="Votre entreprise"
            />
          </div>
          <div className="space-y-2">
            <label htmlFor="siret" className="text-sm font-medium text-gray-700 dark:text-gray-300">
              SIRET
            </label>
            <input
              id="siret"
              name="siret"
              className="w-full rounded-md border border-gray-300 dark:border-gray-700 bg-transparent px-3 py-2 text-sm placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-black dark:focus:ring-white"
              placeholder="123 456 789 00012"
            />
          </div>
        </div>

        <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div className="space-y-2">
            <label htmlFor="name" className="text-sm font-medium text-gray-700 dark:text-gray-300">
              Nom complet *
            </label>
            <input
              id="name"
              name="name"
              required
              className="w-full rounded-md border border-gray-300 dark:border-gray-700 bg-transparent px-3 py-2 text-sm placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-black dark:focus:ring-white"
              placeholder="Jean Dupont"
            />
          </div>
          <div className="space-y-2">
            <label htmlFor="email" className="text-sm font-medium text-gray-700 dark:text-gray-300">
              Email professionnel *
            </label>
            <input
              id="email"
              name="email"
              type="email"
              required
              className="w-full rounded-md border border-gray-300 dark:border-gray-700 bg-transparent px-3 py-2 text-sm placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-black dark:focus:ring-white"
              placeholder="jean@entreprise.com"
            />
          </div>
        </div>

        <div className="space-y-2">
          <label htmlFor="phone" className="text-sm font-medium text-gray-700 dark:text-gray-300">
            Téléphone
          </label>
          <input
            id="phone"
            name="phone"
            type="tel"
            className="w-full rounded-md border border-gray-300 dark:border-gray-700 bg-transparent px-3 py-2 text-sm placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-black dark:focus:ring-white"
            placeholder="+225 01 02 03 04 05"
          />
        </div>

        <div className="space-y-2">
          <label htmlFor="content" className="text-sm font-medium text-gray-700 dark:text-gray-300">
            Détails de votre besoin *
          </label>
          <textarea
            id="content"
            name="content"
            required
            rows={4}
            className="w-full rounded-md border border-gray-300 dark:border-gray-700 bg-transparent px-3 py-2 text-sm placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-black dark:focus:ring-white"
            placeholder="Décrivez les produits, quantités et spécifications souhaitées..."
          />
        </div>

        <button
          type="submit"
          disabled={isLoading}
          className="w-full bg-blue-700 hover:bg-blue-800 text-white font-bold py-3 rounded-md transition-colors flex items-center justify-center gap-2"
        >
          {isLoading && <Loader2 className="w-4 h-4 animate-spin" />}
          Envoyer la demande de devis
        </button>
      </form>
    </div>
  );
}
