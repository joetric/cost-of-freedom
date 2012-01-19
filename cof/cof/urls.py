from django.conf.urls.defaults import patterns, include, url

# Uncomment the next two lines to enable the admin:
from django.contrib import admin
admin.autodiscover()

urlpatterns = patterns('',
    url(r'^$', 'voterid.views.index'),
    url(r'^([^/]{2})/?$', 'voterid.views.index'),
    url(r'^([^/]+)/Co/(.{2})/?$', 'voterid.views.index'),
    url(r'^([^/]+)/County/(.{2})/?$', 'voterid.views.index'),

    url(r'^api/?$', 'voterid.views.api'),
    url(r'^api/(.{2})/?$', 'voterid.views.api'),
    url(r'^api/(.+)/Co/(.{2})/?$', 'voterid.views.api'),
    url(r'^api/(.+)/County/(.{2})/?$', 'voterid.views.api'),
    # Examples:
    # url(r'^$', 'cof.views.home', name='home'),
    # url(r'^cof/', include('cof.foo.urls')),

    # Uncomment the admin/doc line below to enable admin documentation:
    # url(r'^admin/doc/', include('django.contrib.admindocs.urls')),

    # Uncomment the next line to enable the admin:
    url(r'^admin/', include(admin.site.urls)),
)
