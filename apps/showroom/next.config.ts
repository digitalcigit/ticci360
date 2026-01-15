import type { NextConfig } from "next";

const nextConfig: NextConfig = {
  output: 'standalone',
  /* config options here */
  reactCompiler: true,
  images: {
    remotePatterns: [
      {
        protocol: 'http',
        hostname: 'localhost',
        port: '8081',
        pathname: '/storage/**',
      },
      {
        protocol: 'http',
        hostname: 'localhost',
        port: '8000',
        pathname: '/storage/**',
      },
      {
        protocol: 'https',
        hostname: 'api.tic.ci',
        pathname: '/storage/**',
      },
      {
        protocol: 'https',
        hostname: 'tic.ci',
        pathname: '/storage/**',
      },
    ],
  },
};

export default nextConfig;
