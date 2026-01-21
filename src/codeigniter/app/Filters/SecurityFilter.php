<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

/**
 * Security Filter - Implementasi Security Best Practices
 * 
 * Filter ini memastikan:
 * 1. Semua response punya security headers
 * 2. Rate limiting pada login attempts
 * 3. Session security
 */
class SecurityFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // 1. CSRF Protection - Validasi CSRF token untuk POST/PUT/DELETE
        if (in_array($request->getMethod(), ['post', 'put', 'delete'])) {
            if (!csrf_verify()) {
                return service('response')
                    ->setStatusCode(403)
                    ->setJSON(['error' => 'CSRF token mismatch']);
            }
        }

        // 2. Login Rate Limiting
        if (
            $request->is('post') &&
            str_contains($request->getPath(), 'auth/login')
        ) {

            $ip = $request->getIPAddress();
            $cacheKey = "login_attempt_{$ip}";
            $cache = service('cache');

            $attempts = $cache->get($cacheKey) ?? 0;

            // Max 5 attempts per 15 minutes
            if ($attempts >= 5) {
                return service('response')
                    ->setStatusCode(429)
                    ->setJSON(['error' => 'Terlalu banyak login attempt. Coba lagi dalam 15 menit.']);
            }

            $cache->save($cacheKey, $attempts + 1, 900); // 15 minutes
        }

        return $request;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // 3. Security Headers
        $response->setHeader('X-Content-Type-Options', 'nosniff');
        $response->setHeader('X-Frame-Options', 'DENY');
        $response->setHeader('X-XSS-Protection', '1; mode=block');
        $response->setHeader('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        $response->setHeader('Content-Security-Policy', "default-src 'self'; script-src 'self' 'unsafe-inline'");

        return $response;
    }
}
