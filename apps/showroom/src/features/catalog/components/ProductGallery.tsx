'use client';

import { useState } from 'react';
import Image from 'next/image';

interface ProductGalleryProps {
  images: string[];
  name: string;
}

export function ProductGallery({ images, name }: ProductGalleryProps) {
  const [selectedImage, setSelectedImage] = useState(images[0]);

  if (!images.length) {
    return (
      <div className="aspect-square bg-gray-200 rounded-lg flex items-center justify-center text-gray-400">
        No Image Available
      </div>
    );
  }

  return (
    <div className="flex flex-col gap-4">
      <div className="aspect-square relative overflow-hidden rounded-lg bg-gray-100">
        <Image
          src={selectedImage}
          alt={name}
          fill
          className="object-cover object-center"
          priority
        />
      </div>
      {images.length > 1 && (
        <div className="grid grid-cols-4 gap-4">
          {images.map((image, idx) => (
            <button
              key={idx}
              onClick={() => setSelectedImage(image)}
              className={`aspect-square relative overflow-hidden rounded-md bg-gray-100 ${
                selectedImage === image ? 'ring-2 ring-black dark:ring-white' : ''
              }`}
            >
              <Image
                src={image}
                alt={`${name} thumbnail ${idx + 1}`}
                fill
                className="object-cover object-center"
              />
            </button>
          ))}
        </div>
      )}
    </div>
  );
}
