# encoding: utf-8
import datetime
from south.db import db
from south.v2 import SchemaMigration
from django.db import models

class Migration(SchemaMigration):

    def forwards(self, orm):
        
        # Adding model 'Places'
        db.create_table('voterid_places', (
            ('id', self.gf('django.db.models.fields.AutoField')(primary_key=True)),
            ('state', self.gf('django.db.models.fields.TextField')(default='', blank=True)),
            ('vid_req', self.gf('django.db.models.fields.TextField')(default='', blank=True)),
            ('bc_req', self.gf('django.db.models.fields.TextField')(default='', blank=True)),
            ('county', self.gf('django.db.models.fields.TextField')(default='', blank=True)),
            ('vid_agency', self.gf('django.db.models.fields.TextField')(default='', blank=True)),
            ('vid_loc', self.gf('django.db.models.fields.TextField')(default='', blank=True)),
            ('vid_hours', self.gf('django.db.models.fields.TextField')(default='', blank=True)),
            ('vid_phone', self.gf('django.db.models.fields.TextField')(default='', blank=True)),
            ('bc_mail_inst', self.gf('django.db.models.fields.TextField')(default='', blank=True)),
            ('bc_online_inst', self.gf('django.db.models.fields.TextField')(default='', blank=True)),
            ('bc_in_person_agency', self.gf('django.db.models.fields.TextField')(default='', blank=True)),
            ('bc_in_person_cost', self.gf('django.db.models.fields.TextField')(default='', blank=True)),
            ('bc_in_person_loc', self.gf('django.db.models.fields.TextField')(default='', blank=True)),
            ('bc_in_person_hours', self.gf('django.db.models.fields.TextField')(default='', blank=True)),
            ('bc_in_person_phone', self.gf('django.db.models.fields.TextField')(default='', blank=True)),
        ))
        db.send_create_signal('voterid', ['Places'])


    def backwards(self, orm):
        
        # Deleting model 'Places'
        db.delete_table('voterid_places')


    models = {
        'voterid.places': {
            'Meta': {'object_name': 'Places'},
            'bc_in_person_agency': ('django.db.models.fields.TextField', [], {'default': "''", 'blank': 'True'}),
            'bc_in_person_cost': ('django.db.models.fields.TextField', [], {'default': "''", 'blank': 'True'}),
            'bc_in_person_hours': ('django.db.models.fields.TextField', [], {'default': "''", 'blank': 'True'}),
            'bc_in_person_loc': ('django.db.models.fields.TextField', [], {'default': "''", 'blank': 'True'}),
            'bc_in_person_phone': ('django.db.models.fields.TextField', [], {'default': "''", 'blank': 'True'}),
            'bc_mail_inst': ('django.db.models.fields.TextField', [], {'default': "''", 'blank': 'True'}),
            'bc_online_inst': ('django.db.models.fields.TextField', [], {'default': "''", 'blank': 'True'}),
            'bc_req': ('django.db.models.fields.TextField', [], {'default': "''", 'blank': 'True'}),
            'county': ('django.db.models.fields.TextField', [], {'default': "''", 'blank': 'True'}),
            'id': ('django.db.models.fields.AutoField', [], {'primary_key': 'True'}),
            'state': ('django.db.models.fields.TextField', [], {'default': "''", 'blank': 'True'}),
            'vid_agency': ('django.db.models.fields.TextField', [], {'default': "''", 'blank': 'True'}),
            'vid_hours': ('django.db.models.fields.TextField', [], {'default': "''", 'blank': 'True'}),
            'vid_loc': ('django.db.models.fields.TextField', [], {'default': "''", 'blank': 'True'}),
            'vid_phone': ('django.db.models.fields.TextField', [], {'default': "''", 'blank': 'True'}),
            'vid_req': ('django.db.models.fields.TextField', [], {'default': "''", 'blank': 'True'})
        }
    }

    complete_apps = ['voterid']
